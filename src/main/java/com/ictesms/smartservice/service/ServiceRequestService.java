package com.ictesms.smartservice.service;

import com.ictesms.smartservice.entity.Chat;
import com.ictesms.smartservice.entity.Device;
import com.ictesms.smartservice.entity.ServiceRequest;
import com.ictesms.smartservice.enums.ServiceRequestStatus;
import com.ictesms.smartservice.repository.ChatRepository;
import com.ictesms.smartservice.repository.DeviceRepository;
import com.ictesms.smartservice.repository.ServiceRequestRepository;
import org.springframework.stereotype.Service;

import java.time.LocalDateTime;

@Service
public class ServiceRequestService {

    private final ServiceRequestRepository serviceRequestRepository;
    private final ChatRepository chatRepository;
    private final DeviceRepository deviceRepository;

    public ServiceRequestService(ServiceRequestRepository serviceRequestRepository,
                                 ChatRepository chatRepository,
                                 DeviceRepository deviceRepository) {
        this.serviceRequestRepository = serviceRequestRepository;
        this.chatRepository = chatRepository;
        this.deviceRepository = deviceRepository;
    }

    public ServiceRequest createServiceRequest(Long deviceId, String problemDescription) {

        Device device = deviceRepository.findById(deviceId)
                .orElseThrow(() -> new RuntimeException("Device not found"));

        ServiceRequest request = new ServiceRequest();
        request.setDevice(device);
        request.setProblemDescription(problemDescription);
        request.setStatus(ServiceRequestStatus.AI_ACTIVE);
        request.setCreatedAt(LocalDateTime.now());

        ServiceRequest savedRequest = serviceRequestRepository.save(request);

        Chat chat = new Chat();
        chat.setServiceRequest(savedRequest);
        chat.setCreatedAt(LocalDateTime.now());

        chatRepository.save(chat);

        return savedRequest;
    }

    public ServiceRequest escalate(Long requestId) {

        ServiceRequest request = serviceRequestRepository.findById(requestId)
                .orElseThrow(() -> new RuntimeException("ServiceRequest not found"));

        ServiceRequestStatus currentStatus = request.getStatus();

        if (currentStatus != ServiceRequestStatus.AI_ACTIVE &&
                currentStatus != ServiceRequestStatus.AI_RECOMMENDED_ESCALATION) {
            throw new RuntimeException("Escalation not allowed from status: " + currentStatus);
        }

        request.setStatus(ServiceRequestStatus.SEARCHING_TECHNICIAN);

        return serviceRequestRepository.save(request);
    }
}
