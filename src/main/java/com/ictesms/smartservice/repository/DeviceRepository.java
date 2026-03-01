package com.ictesms.smartservice.repository;

import com.ictesms.smartservice.entity.Device;
import org.springframework.data.jpa.repository.JpaRepository;
import java.util.List;

public interface DeviceRepository extends JpaRepository<Device, Long> {
    List<Device> findByOwnerId(Long ownerId);
}
