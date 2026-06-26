$files = Get-ChildItem -Path "resources/views/admin" -Filter "*.blade.php" -Recurse | Where-Object { $_.Name -match "create|edit" }

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw

    # Catch any remaining textareas
    $oldTextarea = 'class="w-full px-\d+ py-\d+ rounded-2xl bg-background border border-border-muted focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all font-body-md text-body-md text-on-background( placeholder:text-outline)?"'
    $newTextarea = 'class="w-full bg-slate-50 border-0 rounded-2xl p-4 text-sm text-heading-slate focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all resize-y shadow-sm font-body-md text-body-md"'
    $content = [regex]::Replace($content, $oldTextarea, $newTextarea)

    Set-Content -Path $file.FullName -Value $content
}
