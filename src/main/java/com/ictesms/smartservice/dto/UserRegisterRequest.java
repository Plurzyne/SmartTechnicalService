package com.ictesms.smartservice.dto;

import lombok.*;

@Getter
@Setter
public class UserRegisterRequest {
    private String firstName;
    private String lastName;
    private String email;
    private String phone;
    private String password;
    private boolean isTechnician; // checkbox from frontend

}
