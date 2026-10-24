<?php
namespace App\Traits;
 
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
 
/**
 * Trait UploadAble
 * @package App\Traits
 */
trait UploadAble
{
    /**
     * @param UploadedFile $file
     * @param null $folder
     * @param string $disk
     * @param null $filename
     * @return false|string
     */
    public function uploadOne(UploadedFile $file, $folder = null, $disk = 'public', $filename = null)
    {
        // 1. Sanitize folder to prevent directory traversal
        $folder = !is_null($folder) ? trim(str_replace(['..', "\0"], '', $folder), '/\\') : null;

        // 2. Sanitize filename to prevent arbitrary path traversal or overwrites
        if (!is_null($filename)) {
            $name = preg_replace('/[^a-zA-Z0-9_\-]/', '', pathinfo($filename, PATHINFO_FILENAME));
            if (empty($name)) {
                $name = Str::random(25);
            }
        } else {
            $name = Str::random(25);
        }

        $originalName = (string)$file->getClientOriginalName();
        $clientExt = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', (string)$file->getClientOriginalExtension()));
        $guessedExt = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', (string)$file->guessExtension()));
        $detectedMime = strtolower((string)$file->getMimeType());

        // 3. Block double-extension evasion attempts (e.g., shell.php.jpg or payload.exe.png)
        if (preg_match('/\.(php[0-9]?|phtml|phar|sh|bash|bat|cmd|exe|svg|js|html|htm|asp|aspx|jsp)\./i', $originalName)) {
            throw new \InvalidArgumentException('Uploaded file contains prohibited multi-extension sequence.');
        }

        // 4. Strict blacklist of dangerous executable and scriptable file extensions
        $blockedExtensions = [
            'php', 'php3', 'php4', 'php5', 'php7', 'php8', 'phtml', 'phar',
            'inc', 'sh', 'bash', 'bat', 'cmd', 'exe', 'com', 'dll', 'bin',
            'cgi', 'pl', 'py', 'asp', 'aspx', 'jsp', 'jspx', 'htaccess', 'htpasswd',
            'svg', 'js', 'html', 'htm', 'xhtml'
        ];

        if (in_array($clientExt, $blockedExtensions, true) || in_array($guessedExt, $blockedExtensions, true)) {
            throw new \InvalidArgumentException('Uploaded file type is disallowed or potentially dangerous.');
        }

        // 5. Strict allowlist of permitted extensions
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'ico', 'pdf', 'bmp'];
        if (!in_array($clientExt, $allowedExtensions, true) || !in_array($guessedExt, $allowedExtensions, true)) {
            throw new \InvalidArgumentException('Uploaded file extension is not in the allowed extensions list.');
        }

        // 6. Server-detected MIME validation & SVG rejection
        $allowedMimes = [
            'image/jpeg', 'image/png', 'image/gif', 'image/webp',
            'image/x-icon', 'image/vnd.microsoft.icon', 'application/pdf', 'image/bmp'
        ];

        if (!in_array($detectedMime, $allowedMimes, true) || $detectedMime === 'image/svg+xml') {
            throw new \InvalidArgumentException('Uploaded file MIME type is disallowed or does not match permitted formats.');
        }

        $extension = $guessedExt ?: $clientExt;

        return $file->storeAs(
            $folder,
            $name . "." . $extension,
            $disk
        );
    }
 
    /**
     * @param null $path
     * @param string $disk
     */
    public function deleteOne($path = null, $disk = 'public')
    {
        Storage::disk($disk)->delete($path);
    }
}