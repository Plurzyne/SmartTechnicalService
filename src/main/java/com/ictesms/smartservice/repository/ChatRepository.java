package com.ictesms.smartservice.repository;

import com.ictesms.smartservice.entity.Chat;
import org.springframework.data.jpa.repository.JpaRepository;

public interface ChatRepository extends JpaRepository<Chat, Long> {
}
