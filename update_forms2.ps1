$files = Get-ChildItem -Path "resources/views/admin" -Filter "*.blade.php" -Recurse | Where-Object { $_.Name -match "create|edit" }

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw

    # 1. Form Card Container
    $content = [regex]::Replace($content, 'bg-surface-container-lowest rounded-[23]xl border border-border-muted ambient-shadow p-\d+( max-w-\d+xl mx-auto)?', 'bg-white rounded-3xl border border-muted p-6 md:p-8$1')

    # 2. File Upload Area
    $content = [regex]::Replace($content, 'border-2 border-dashed border-(border-muted|outline-variant) (bg-surface-container-lowest )?rounded-2xl p-\d+ .*?transition-colors cursor-pointer group relative', 'border-2 border-dashed border-outline-variant bg-slate-50/50 hover:bg-slate-50 rounded-2xl p-10 flex flex-col items-center justify-center gap-3 transition-colors cursor-pointer group relative')

    # 3. Submit Button
    $content = [regex]::Replace($content, 'px-\d+ py-\d+ rounded-full bg-primary text-on-primary font-label-md text-label-md hover:shadow-lg hover:shadow-primary/20 hover:-translate-y-0.5 transition-all flex items-center gap-\d+', 'w-full md:w-auto px-8 py-3 rounded-full font-label-md text-label-md text-white bg-gradient-to-r from-primary to-primary-container shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2')

    # 4. Cancel Button
    $content = [regex]::Replace($content, 'px-\d+ py-\d+ rounded-full border border-border-muted text-on-surface-variant font-label-md text-label-md hover:bg-surface-variant transition-colors', 'w-full md:w-auto px-6 py-3 rounded-full font-label-md text-label-md text-slate-600 hover:bg-slate-100 transition-colors')
    
    # 5. Form Actions Container
    $content = [regex]::Replace($content, 'flex justify-end gap-\d+', 'mt-10 pt-6 border-t border-muted flex flex-col-reverse md:flex-row justify-end items-center gap-4')

    # 6. Remove the old divider
    $content = [regex]::Replace($content, '<div class="h-px bg-border-muted w-full my-2"></div>\s*', '')

    Set-Content -Path $file.FullName -Value $content
}
