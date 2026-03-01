package com.ictesms.smartservice.dto;

import com.ictesms.smartservice.enums.SenderType;
import lombok.Getter;
import lombok.Setter;

@Getter
@Setter
public class MessageRequest {

    private Long chatId;
    private SenderType senderType;
    private String content;
}
