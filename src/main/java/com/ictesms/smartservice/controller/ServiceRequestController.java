package com.ictesms.smartservice.controller;

import com.ictesms.smartservice.dto.ServiceRequestRequest;
import com.ictesms.smartservice.entity.ServiceRequest;
import com.ictesms.smartservice.service.ServiceRequestService;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/service-requests")
public class ServiceRequestController {

    private final ServiceRequestService serviceRequestService;

    public ServiceRequestController(ServiceRequestService serviceRequestService) {
        this.serviceRequestService = serviceRequestService;
    }

    @PostMapping
    public ServiceRequest createServiceRequest(
            @RequestBody ServiceRequestRequest request) {

        return serviceRequestService.createServiceRequest(
                request.getDeviceId(),
                request.getProblemDescription()
        );
    }

    @PostMapping("/{id}/escalate")
    public ServiceRequest escalate(@PathVariable Long id) {
        return serviceRequestService.escalate(id);
    }

}
