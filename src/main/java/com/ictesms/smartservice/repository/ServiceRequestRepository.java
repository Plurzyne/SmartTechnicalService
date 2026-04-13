package com.ictesms.smartservice.repository;

import com.ictesms.smartservice.entity.ServiceRequest;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

import java.util.List;

public interface ServiceRequestRepository extends JpaRepository<ServiceRequest, Long> {
    @Query("""
    SELECT sr 
    FROM ServiceRequest sr 
    WHERE sr.device.owner.id = :userId 
    ORDER BY sr.id DESC
    """)
    List<ServiceRequest> findByUserId(@Param("userId") Long userId);
}
