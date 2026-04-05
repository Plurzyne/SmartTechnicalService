package com.ictesms.smartservice.controller;

import com.ictesms.smartservice.dto.DeviceRequest;
import com.ictesms.smartservice.entity.Device;
import com.ictesms.smartservice.service.DeviceService;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@CrossOrigin(origins = "*")
@RestController
@RequestMapping("/api/devices")
public class DeviceController {

    private final DeviceService deviceService;

    public DeviceController(DeviceService deviceService) {
        this.deviceService = deviceService;
    }

    @PostMapping
    public Device createDevice(@RequestBody DeviceRequest request) {
        return deviceService.createDevice(
                request.getOwnerId(),
                request.getDeviceName(),
                request.getDeviceType()
        );
    }

    @GetMapping("/owner/{ownerId}")
    public List<Device> getDevicesByOwner(@PathVariable Long ownerId) {
        return deviceService.getDevicesByOwner(ownerId);
    }

    @PutMapping("/{deviceId}")
    public Device updateDevice(@PathVariable Long deviceId,
                               @RequestBody DeviceRequest request) {

        return deviceService.updateDevice(
                deviceId,
                request.getDeviceName(),
                request.getDeviceType()
        );
    }

    @DeleteMapping("/{deviceId}")
    public void deleteDevice(@PathVariable Long deviceId) {
        deviceService.deleteDevice(deviceId);
    }
}
