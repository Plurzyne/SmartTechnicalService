package com.ictesms.smartservice.service;

import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.ictesms.smartservice.dto.AiResult;
import com.ictesms.smartservice.entity.Chat;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.http.*;
import org.springframework.stereotype.Service;
import org.springframework.web.client.RestTemplate;

import java.util.List;
import java.util.Map;
import java.util.stream.Collectors;

@Service
public class AiService {

    @Value("${openai.api.key}")
    private String apiKey;

    private final ObjectMapper objectMapper = new ObjectMapper();
    private final RestTemplate restTemplate = new RestTemplate();

    public AiResult generateResponse(Chat chat) {

        String deviceName = chat.getServiceRequest().getDevice().getName();
        String deviceType = chat.getServiceRequest().getDevice().getType();
        String problem = chat.getServiceRequest().getProblemDescription();

        String history = chat.getMessages().stream()
                .map(m -> m.getSenderType() + ": " + m.getContent())
                .collect(Collectors.joining("\n"));

        String prompt = """
You are a professional technical troubleshooting assistant.

Device: %s (%s)
Initial Problem: %s

Conversation History:
%s

Respond strictly in JSON format and in Azerbaijani language:
{
  "reply": "your helpful professional response",
  "shouldEscalate": true or false
}
Only return valid JSON.
""".formatted(deviceName, deviceType, problem, history);

        Map<String, Object> requestBody = Map.of(
                "model", "gpt-4o-mini",
                "messages", List.of(
                        Map.of("role", "user", "content", prompt)
                )
        );

        HttpHeaders headers = new HttpHeaders();
        headers.setBearerAuth(apiKey);
        headers.setContentType(MediaType.APPLICATION_JSON);

        HttpEntity<Map<String, Object>> entity =
                new HttpEntity<>(requestBody, headers);

        String response = restTemplate.postForObject(
                "https://api.openai.com/v1/chat/completions",
                entity,
                String.class
        );

        try {
            JsonNode root = objectMapper.readTree(response);
            String content = root.get("choices").get(0)
                    .get("message")
                    .get("content")
                    .asText();

            JsonNode aiJson = objectMapper.readTree(content);

            String reply = aiJson.get("reply").asText();
            boolean escalate = aiJson.get("shouldEscalate").asBoolean();

            return new AiResult(reply, escalate);

        } catch (Exception e) {
            throw new RuntimeException("AI response parsing failed", e);
        }
    }
}