$files = Get-ChildItem -Path "resources/views/admin" -Filter "*.blade.php" -Recurse | Where-Object { $_.Name -match "create|edit" }

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw

    # 1. Form Card Container
    $content = $content -replace 'bg-surface-container-lowest rounded-3xl border border-border-muted ambient-shadow p-[46]( max-w-[34]xl mx-auto)?', 'bg-white rounded-3xl border border-muted p-6 md:p-8$1'

    # 2. Input/Select/Textarea styling
    $oldInputClass = 'w-full (pl-\d+ pr-\d+ )?py-[12] rounded-2xl bg-background border border-border-muted focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all font-body-md text-body-md text-on-background( placeholder:text-outline)?'
    
    $newInputClass = 'w-full bg-slate-50 border-0 rounded-xl py-3 $1text-sm text-heading-slate focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm font-body-md text-body-md'
    $content = $content -replace $oldInputClass, $newInputClass

    # Fix Textarea specific padding (since textarea might not have pl-10)
    $oldTextareaClass = 'w-full p-4 rounded-2xl bg-background border border-border-muted focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all font-body-md text-body-md text-on-background placeholder:text-outline'
    $newTextareaClass = 'w-full bg-slate-50 border-0 rounded-2xl p-4 text-sm text-heading-slate focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all resize-y shadow-sm font-body-md text-body-md'
    $content = $content -replace $oldTextareaClass, $newTextareaClass

    # 3. Label styling (change text-on-background to text-slate-700)
    $content = $content -replace 'class="font-label-md text-label-md text-on-background"', 'class="font-label-md text-label-md text-slate-700 flex items-center gap-1"'

    # 4. Icon styling in inputs (add pointer-events-none)
    $content = $content -replace 'class="material-symbols-outlined absolute (left|right)-4 top-1/2 -translate-y-1/2 text-outline( z-10)?"', 'class="material-symbols-outlined absolute $1-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none"'

    # 5. File Upload Area
    $oldUpload = 'border-2 border-dashed border-outline-variant bg-surface-container-lowest hover:bg-surface-container-low rounded-2xl p-6 flex flex-col items-center justify-center gap-2 transition-colors cursor-pointer group'
    $newUpload = 'border-2 border-dashed border-outline-variant bg-slate-50/50 hover:bg-slate-50 rounded-2xl p-10 flex flex-col items-center justify-center gap-3 transition-colors cursor-pointer group'
    $content = $content -replace $oldUpload, $newUpload

    # 6. Submit Button
    $oldSubmit = 'bg-primary text-on-primary px-6 py-2 rounded-2xl hover:bg-primary/90 transition-colors font-label-md text-label-md'
    $newSubmit = 'w-full md:w-auto px-8 py-3 rounded-full font-label-md text-label-md text-white bg-gradient-to-r from-primary to-primary-container shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2'
    $content = $content -replace $oldSubmit, $newSubmit

    # 7. Cancel Button
    $oldCancel = 'bg-surface-container hover:bg-surface-container-high text-on-surface-variant px-6 py-2 rounded-2xl transition-colors font-label-md text-label-md'
    $newCancel = 'w-full md:w-auto px-6 py-3 rounded-full font-label-md text-label-md text-slate-600 hover:bg-slate-100 transition-colors'
    $content = $content -replace $oldCancel, $newCancel

    Set-Content -Path $file.FullName -Value $content
}
