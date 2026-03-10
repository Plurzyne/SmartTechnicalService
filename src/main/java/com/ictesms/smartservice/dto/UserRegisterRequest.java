package com.ictesms.smartservice.dto;

import lombok.*;

@Getter
@Setter
public class UserRegisterRequest {
    private String email;
    private String firstName;
    private String lastName;
    private String phone;
    private String password;
    private String role;
}
