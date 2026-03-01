package com.ictesms.smartservice.service;

import com.ictesms.smartservice.dto.AiResult;
import com.ictesms.smartservice.dto.MessageResponse;
import com.ictesms.smartservice.entity.Chat;
import com.ictesms.smartservice.entity.Message;
import com.ictesms.smartservice.entity.ServiceRequest;
import com.ictesms.smartservice.enums.SenderType;
import com.ictesms.smartservice.enums.ServiceRequestStatus;
import com.ictesms.smartservice.repository.ChatRepository;
import com.ictesms.smartservice.repository.MessageRepository;
import com.ictesms.smartservice.repository.ServiceRequestRepository;
import jakarta.transaction.Transactional;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class MessageService {

    private final MessageRepository messageRepository;
    private final ChatRepository chatRepository;
    private final AiService aiService;
    private final ServiceRequestRepository serviceRequestRepository;

    public MessageService(MessageRepository messageRepository,
                          ChatRepository chatRepository,
                          AiService aiService,
                          ServiceRequestRepository serviceRequestRepository) {
        this.messageRepository = messageRepository;
        this.chatRepository = chatRepository;
        this.aiService = aiService;
        this.serviceRequestRepository = serviceRequestRepository;
    }

    @Transactional
    public MessageResponse sendMessage(Long chatId, SenderType senderType, String content) {

        Chat chat = chatRepository.findById(chatId)
                .orElseThrow(() -> new RuntimeException("Chat not found"));

        // Save customer message
        Message message = new Message();
        message.setChat(chat);
        message.setSenderType(senderType);
        message.setContent(content);
        message.setTimestamp(java.time.LocalDateTime.now());

        Message savedMessage = messageRepository.save(message);

        // If customer → generate AI reply
        if (senderType == SenderType.CUSTOMER) {

            AiResult aiResult = aiService.generateResponse(chat);

            Message aiMessage = new Message();
            aiMessage.setChat(chat);
            aiMessage.setSenderType(SenderType.AI);
            aiMessage.setContent(aiResult.getReply());
            aiMessage.setTimestamp(java.time.LocalDateTime.now());

            Message savedAiMessage = messageRepository.save(aiMessage);

            if (aiResult.isShouldEscalate()) {
                ServiceRequest serviceRequest = chat.getServiceRequest();
                serviceRequest.setStatus(ServiceRequestStatus.AI_RECOMMENDED_ESCALATION);
                serviceRequestRepository.save(serviceRequest);
            }

            return new MessageResponse(
                    savedAiMessage.getId(),
                    savedAiMessage.getSenderType(),
                    savedAiMessage.getContent(),
                    savedAiMessage.getTimestamp()
            );
        }

        // Otherwise return the saved message
        return new MessageResponse(
                savedMessage.getId(),
                savedMessage.getSenderType(),
                savedMessage.getContent(),
                savedMessage.getTimestamp()
        );
    }



    public List<MessageResponse> getChatMessages(Long chatId) {

        return messageRepository
                .findByChatIdOrderByTimestampAsc(chatId)
                .stream()
                .map(message -> new MessageResponse(
                        message.getId(),
                        message.getSenderType(),
                        message.getContent(),
                        message.getTimestamp()
                ))
                .toList();
    }
}
