package com.ictesms.smartservice.service;

import com.ictesms.smartservice.entity.Device;
import com.ictesms.smartservice.entity.User;
import com.ictesms.smartservice.repository.DeviceRepository;
import com.ictesms.smartservice.repository.UserRepository;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class DeviceService {

    private final DeviceRepository deviceRepository;
    private final UserRepository userRepository;

    public DeviceService(DeviceRepository deviceRepository,
                         UserRepository userRepository) {
        this.deviceRepository = deviceRepository;
        this.userRepository = userRepository;
    }

    public Device createDevice(Long ownerId, String name, String type) {

        User owner = userRepository.findById(ownerId)
                .orElseThrow(() -> new RuntimeException("User not found"));

        Device device = new Device();
        device.setOwner(owner);
        device.setName(name);
        device.setType(type);

        return deviceRepository.save(device);
    }

    public List<Device> getDevicesByOwner(Long ownerId) {
        return deviceRepository.findByOwnerId(ownerId);
    }
}
