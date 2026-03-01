package com.ictesms.smartservice.dto;

import lombok.AllArgsConstructor;
import lombok.Getter;

@Getter
@AllArgsConstructor
public class AiResult {

    private String reply;
    private boolean shouldEscalate;
}
