package com.ictesms.smartservice.controller;

import com.ictesms.smartservice.dto.LoginRequest;
import com.ictesms.smartservice.dto.UserRegisterRequest;
import com.ictesms.smartservice.entity.User;
import com.ictesms.smartservice.service.UserService;
import org.springframework.http.*;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/api/users")
@CrossOrigin(origins = "*")
public class UserController {

    private final UserService userService;

    public UserController(UserService userService) {
        this.userService = userService;
    }

    @PostMapping("/register")
    public ResponseEntity<?> register(@RequestBody UserRegisterRequest request) {

        userService.register(request);

        return ResponseEntity.ok("User registered successfully");
    }

    @PostMapping("/login")
    public ResponseEntity<?> login(@RequestBody LoginRequest request) {

        User user = userService.login(request);

        return ResponseEntity.ok(user);
    }
}
