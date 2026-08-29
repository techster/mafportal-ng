$ErrorActionPreference = "Stop"
$listeners = @(Get-NetTCPConnection -LocalAddress 127.0.0.1 -LocalPort 8001 -State Listen -ErrorAction SilentlyContinue)
foreach ($listener in $listeners) {
    Stop-Process -Id $listener.OwningProcess -Force -ErrorAction SilentlyContinue
}
$python = "c:\Users\pavel\.copilot\repos\mafportal-ng\.venv\Scripts\python.exe"
if (!(Test-Path $python)) { throw "Required interpreter not found: $python" }
Start-Process -FilePath $python -ArgumentList @("-m", "uvicorn", "app.main:app", "--reload", "--host", "127.0.0.1", "--port", "8001") -WorkingDirectory "c:\Users\pavel\.copilot\repos\mafportal-ng\backend" -WindowStyle Hidden
$deadline = (Get-Date).AddSeconds(30)
do {
    Start-Sleep -Milliseconds 500
    $listener = Get-NetTCPConnection -LocalAddress 127.0.0.1 -LocalPort 8001 -State Listen -ErrorAction SilentlyContinue
} until ($listener -or (Get-Date) -gt $deadline)
if (!$listener) { throw "Listener did not start" }
$listener | Select-Object LocalAddress, LocalPort, OwningProcess | ConvertTo-Json -Compress