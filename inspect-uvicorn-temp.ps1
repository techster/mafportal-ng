$listener = Get-NetTCPConnection -LocalAddress 127.0.0.1 -LocalPort 8001 -State Listen
Get-CimInstance Win32_Process -Filter "ProcessId = $($listener.OwningProcess)" | Select-Object ProcessId,ParentProcessId,Name,CommandLine | Format-List
Get-CimInstance Win32_Process -Filter "ParentProcessId = $($listener.OwningProcess)" | Select-Object ProcessId,ParentProcessId,Name,CommandLine | Format-List
& "c:\Users\pavel\.copilot\repos\mafportal-ng\.venv\Scripts\python.exe" -c "import app.admin; print(app.admin.__file__)"