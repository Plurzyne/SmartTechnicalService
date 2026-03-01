package com.ictesms.smartservice.repository;

import com.ictesms.smartservice.entity.ServiceRequest;
import org.springframework.data.jpa.repository.JpaRepository;

public interface ServiceRequestRepository extends JpaRepository<ServiceRequest, Long> {
}
