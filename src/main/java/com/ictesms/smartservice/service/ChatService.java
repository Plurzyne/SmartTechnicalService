package com.ictesms.smartservice.service;

import com.ictesms.smartservice.entity.Chat;
import com.ictesms.smartservice.repository.ChatRepository;
import org.springframework.stereotype.Service;

import java.util.Optional;

@Service
public class ChatService {

    private final ChatRepository chatRepository;

    public ChatService(ChatRepository chatRepository) {
        this.chatRepository = chatRepository;
    }

    public Optional<Chat> getChatById(Long chatId) {
        return chatRepository.findById(chatId);
    }
}
