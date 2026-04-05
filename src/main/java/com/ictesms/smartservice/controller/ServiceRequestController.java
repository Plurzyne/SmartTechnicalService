package com.ictesms.smartservice.controller;

import com.ictesms.smartservice.dto.ServiceRequestRequest;
import com.ictesms.smartservice.entity.ServiceRequest;
import com.ictesms.smartservice.service.ServiceRequestService;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@CrossOrigin(origins = "*")
@RestController
@RequestMapping("/api/service-requests")
public class ServiceRequestController {

    private final ServiceRequestService serviceRequestService;

    public ServiceRequestController(ServiceRequestService serviceRequestService) {
        this.serviceRequestService = serviceRequestService;
    }

    @GetMapping("/user/{userId}")
    public List<ServiceRequest> getByUser(@PathVariable Long userId) {
        return serviceRequestService.getRequestsByUser(userId);
    }

    @PostMapping
    public ServiceRequest createServiceRequest(
            @RequestBody ServiceRequestRequest request) {

        return serviceRequestService.createServiceRequest(
                request.getDeviceId(),
                request.getProblemDescription()
        );
    }

    @PutMapping("/{id}/cancel")
    public ServiceRequest cancelRequest(@PathVariable Long id) {
        return serviceRequestService.cancelRequest(id);
    }

    @DeleteMapping("/{id}")
    public void deleteRequest(@PathVariable Long id) {
        serviceRequestService.deleteRequest(id);
    }

    @PostMapping("/{id}/escalate")
    public ServiceRequest escalate(@PathVariable Long id) {
        return serviceRequestService.escalate(id);
    }

}
