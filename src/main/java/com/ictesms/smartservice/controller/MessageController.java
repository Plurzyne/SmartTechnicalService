package com.ictesms.smartservice.controller;

import com.ictesms.smartservice.dto.MessageRequest;
import com.ictesms.smartservice.dto.MessageResponse;
import com.ictesms.smartservice.service.MessageService;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@CrossOrigin(origins = "*")
@RestController
@RequestMapping("/messages")
public class MessageController {

    private final MessageService messageService;

    public MessageController(MessageService messageService) {
        this.messageService = messageService;
    }

    @PostMapping
    public MessageResponse sendMessage(@RequestBody MessageRequest request) {
        return messageService.sendMessage(
                request.getChatId(),
                request.getSenderType(),
                request.getContent()
        );
    }

    @GetMapping("/chat/{chatId}")
    public List<MessageResponse> getMessages(@PathVariable Long chatId) {
        return messageService.getChatMessages(chatId);
    }
}
