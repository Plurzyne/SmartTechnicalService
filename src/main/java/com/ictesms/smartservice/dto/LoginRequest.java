package com.ictesms.smartservice.dto;

import lombok.*;

@Getter
@Setter
public class LoginRequest {

    private String phone;
    private String password;
}