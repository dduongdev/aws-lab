package com.example.loginapp.controller;

import com.example.loginapp.service.AuthService;
import jakarta.servlet.http.HttpSession;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;

@Controller
public class AuthController {
    private final AuthService authService;

    public AuthController(AuthService authService) {
        this.authService = authService;
    }

    @GetMapping("/")
    public String loginPage(Model model) {
        return "login";
    }

    @PostMapping("/login")
    public String login(
            @RequestParam String username,
            @RequestParam String password,
            HttpSession session,
            Model model) {

        if (authService.authenticate(username, password)) {
            session.setAttribute("username", username);
            return "redirect:/home";
        }

        model.addAttribute("error", "Tên đăng nhập hoặc mật khẩu không đúng");
        return "login";
    }

    @GetMapping("/home")
    public String home(HttpSession session, Model model) {
        Object username = session.getAttribute("username");
        if (username == null) {
            return "redirect:/";
        }
        model.addAttribute("username", username);
        return "home";
    }

    @GetMapping("/logout")
    public String logout(HttpSession session) {
        session.invalidate();
        return "redirect:/";
    }
}
