package com.ictesms.smartservice.dto;

import lombok.Getter;
import lombok.Setter;

@Getter
@Setter
public class UserUpdateRequest {
    private String firstName;
    private String lastName;
    private String email;
    private String phone;
    private String password; // optional
}