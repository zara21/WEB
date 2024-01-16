const { spawn } = require('child_process');

const phpScriptPath = 'C:\\xampp\\htdocs\\WEB\\fetch_data.php'; // Adjust the path accordingly
const phpExecutablePath = 'C:\\xampp\\php\\php.exe'; // Adjust the path to your PHP executable

const phpProcess = spawn(phpExecutablePath, ['-dxdebug.mode=develop', phpScriptPath]);

phpProcess.on('close', (code) => {
  console.log(`PHP process exited with code ${code}`);
});

phpProcess.stdout.on('data', (data) => {
  console.log(`PHP stdout: ${data}`);
});

phpProcess.stderr.on('data', (data) => {
  console.error(`PHP stderr: ${data}`);
});
