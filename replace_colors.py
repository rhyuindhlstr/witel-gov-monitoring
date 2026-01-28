import os
import re

# Define the directory to search
base_dir = r'd:\laragon\www\witel-gov-monitoring\resources\views'

# Define replacements
replacements = {
    'text-primary': 'text-danger',
    'btn-outline-primary': 'btn-outline-danger',
    'btn-primary': 'btn-telkom',
    'bg-primary': 'bg-danger',
}

# Process all .blade.php files
for root, dirs, files in os.walk(base_dir):
    for file in files:
        if file.endswith('.blade.php'):
            filepath = os.path.join(root, file)
            
            try:
                with open(filepath, 'r', encoding='utf-8') as f:
                    content = f.read()
                
                # Apply replacements
                modified = False
                for old, new in replacements.items():
                    if old in content:
                        content = content.replace(old, new)
                        modified = True
                
                # Write back if modified
                if modified:
                    with open(filepath, 'w', encoding='utf-8') as f:
                        f.write(content)
                    print(f'Updated: {filepath}')
            except Exception as e:
                print(f'Error processing {filepath}: {e}')

print('Color replacement complete!')
