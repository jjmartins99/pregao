@echo off
title Reinstalar Vite + Laravel Vite Plugin (Breeze Blade)
color 0A
echo ================================================
echo   🚀 REPARAR FRONT-END LARAVEL BREEZE (BLADE)
echo ================================================
echo.

:: --- Verificar Node e npm ---
where node >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERRO] Node.js nao encontrado. Instale antes de continuar.
    pause
    exit /b
)
where npm >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERRO] npm nao encontrado. Verifique sua instalacao.
    pause
    exit /b
)

for /f "tokens=* usebackq" %%A in (`node -v`) do set NODE_VER=%%A
for /f "tokens=* usebackq" %%A in (`npm -v`) do set NPM_VER=%%A
echo [INFO] Node.js: %NODE_VER%
echo [INFO] npm: %NPM_VER%
echo.

setlocal enabledelayedexpansion
set NODE_MAIN=!NODE_VER:~1,2!
if !NODE_MAIN! lss 18 (
    echo [ALERTA] ⚠️ O Node precisa ser >= 18. Versoes antigas causam erros com Vite.
    choice /M "Deseja continuar mesmo assim?"
    if errorlevel 2 exit /b
)
endlocal

echo [INFO] Limpando dependencias antigas...
taskkill /IM node.exe /F >nul 2>nul
if exist node_modules rmdir /S /Q node_modules
if exist package-lock.json del /F /Q package-lock.json
npm cache clean --force

echo [INFO] Reinstalando dependencias base...
npm install --legacy-peer-deps

echo [INFO] Instalando versoes compativeis de Vite + Laravel Plugin...
npm install vite@6.0.11 laravel-vite-plugin@1.0.2 --save-dev

echo.
echo ================================================
echo   ✅ Instalacao concluida!
echo ================================================
echo.

npm list vite laravel-vite-plugin
echo.

echo [INFO] Compilando assets (npm run build ou dev)...
findstr /C:"\"build\"" package.json >nul
if %errorlevel%==0 (
    npm run build
) else (
    start "Servidor de desenvolvimento" cmd /c "npm run dev"
    timeout /t 5 >nul
    echo [INFO] Abrindo navegador em http://localhost:5173 ...
    start http://localhost:5173
)

echo.
echo ================================================
echo   ✅ Front-end recompilado com sucesso!
echo ================================================
pause
