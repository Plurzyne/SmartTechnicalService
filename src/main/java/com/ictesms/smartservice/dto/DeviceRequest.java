package com.ictesms.smartservice.dto;

import lombok.Getter;
import lombok.Setter;

@Getter
@Setter
public class DeviceRequest {

    private Long ownerId;
    private String deviceName;
    private String deviceType;
}
