package com.ictesms.smartservice.dto;

import com.ictesms.smartservice.enums.SenderType;
import lombok.AllArgsConstructor;
import lombok.Getter;

import java.time.LocalDateTime;

@Getter
@AllArgsConstructor
public class MessageResponse {

    private Long id;
    private SenderType senderType;
    private String content;
    private LocalDateTime timestamp;
}
