package com.ictesms.smartservice.dto;

import lombok.Getter;
import lombok.Setter;

@Getter
@Setter
public class ServiceRequestRequest {

    private Long deviceId;
    private String problemDescription;
}
