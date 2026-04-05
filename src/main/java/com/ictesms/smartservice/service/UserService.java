package com.ictesms.smartservice.service;

import com.ictesms.smartservice.dto.LoginRequest;
import com.ictesms.smartservice.dto.UserRegisterRequest;
import com.ictesms.smartservice.entity.User;
import com.ictesms.smartservice.repository.UserRepository;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

@Service
public class UserService {

    private final UserRepository userRepository;
    private final PasswordEncoder passwordEncoder;

    public UserService(UserRepository userRepository,
                       PasswordEncoder passwordEncoder) {
        this.userRepository = userRepository;
        this.passwordEncoder = passwordEncoder;
    }

    public void register(UserRegisterRequest request) {

        User user = new User();

        user.setEmail(request.getEmail());
        user.setFirstName(request.getFirstName());
        user.setLastName(request.getLastName());
        user.setPhone(request.getPhone());
        user.setPassword(passwordEncoder.encode(request.getPassword()));

        if (request.isTechnician()) {
            user.setRole("TECHNICIAN");
        } else {
            user.setRole("CUSTOMER");
        }

        user.setLatitude(null);
        user.setLongitude(null);
        user.setAvailable(false);

        userRepository.save(user);
    }

    public User login(LoginRequest request) {

        User user = userRepository.findByPhone(request.getPhone())
                .orElseThrow(() -> new RuntimeException("User not found"));

        if (!passwordEncoder.matches(request.getPassword(), user.getPassword())) {
            throw new RuntimeException("Invalid password");
        }

        return user;
    }

    public User getUserById(Long id) {
        return userRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("User not found"));
    }
}