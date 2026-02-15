@echo off
NET SESSION >nul 2>&1
IF %ERRORLEVEL% NEQ 0 (
    echo This script requires Administrator privileges.
    echo Please right-click on this file and select "Run as administrator".
    pause
    exit /b
)

echo ==========================================
echo Starting Docker and WSL Installation
echo ==========================================

echo [1/3] Enabling Windows Subsystem for Linux Features...
dism.exe /online /enable-feature /featurename:Microsoft-Windows-Subsystem-Linux /all /norestart
dism.exe /online /enable-feature /featurename:VirtualMachinePlatform /all /norestart

echo [2/3] Installing WSL (this may take a few minutes)...
wsl --install -d Ubuntu --web-download

echo [3/3] Installing Docker Desktop...
winget install Docker.DockerDesktop --accept-package-agreements --accept-source-agreements

echo.
echo ==========================================
echo Installation commands finished.
echo IMPORTANT: You MUST restart your computer now for changes to take effect.
echo After restart, open Docker Desktop to finish setup.
echo ==========================================
pause

