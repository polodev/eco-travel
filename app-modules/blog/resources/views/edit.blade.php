<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Blog Post</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update blog post with multilingual support</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin-dashboard.blog.show', $blog->slug) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View Post
                    </a>
                    <a href="{{ route('admin-dashboard.blog.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('admin-dashboard.blog.update', $blog->slug) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- English Title -->
                    <div>
                        <label for="english_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            English Title *
                        </label>
                        <input type="text" 
                               id="english_title"
                               name="english_title"
                               value="{{ old('english_title', $blog->english_title) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter English title for slug generation"
                               required>
                        @error('english_title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Slug (Auto-generated, can be changed)
                        </label>
                        <input type="text" 
                               id="slug"
                               name="slug"
                               value="{{ old('slug', $blog->slug) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Auto-generated from English title">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Other Fields -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Status *
                        </label>
                        <select id="status" 
                                name="status"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @foreach (\Modules\Blog\Models\Blog::getAvailableStatuses() as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $blog->status) === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Published At -->
                    <div>
                        <label for="published_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Published At
                        </label>
                        <input type="datetime-local" 
                               id="published_at"
                               name="published_at"
                               value="{{ old('published_at', $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('published_at')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Position -->
                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Position
                        </label>
                        <input type="number" 
                               id="position"
                               name="position"
                               value="{{ old('position', $blog->position) }}"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Order position (0 = first)">
                        @error('position')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tags -->
                <div>
                    <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Tags
                    </label>
                    <select id="tags"
                            name="tags[]"
                            multiple
                            class="w-full">
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $blog->tags->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tags')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    @error('tags.*')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Featured Image -->
                <div>
                    <label for="featured_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Featured Image URL
                    </label>
                    <input type="url" 
                           id="featured_image"
                           name="featured_image"
                           value="{{ old('featured_image', $blog->featured_image) }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="https://example.com/image.jpg">
                    @error('featured_image')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Language Tabs -->
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button type="button" 
                                class="language-tab active whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-blue-500 text-blue-600 dark:border-blue-400 dark:text-blue-400"
                                data-lang="en">
                            English
                        </button>
                        <button type="button" 
                                class="language-tab whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-500"
                                data-lang="bn">
                            Bengali
                        </button>
                    </nav>
                </div>

                <!-- English Fields -->
                <div id="lang-en" class="language-content">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">English Content</h3>
                    
                    <div class="space-y-4">
                        <!-- Title English -->
                        <div>
                            <label for="title_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Title (English) *
                            </label>
                            <input type="text" 
                                   id="title_en"
                                   name="title[en]"
                                   value="{{ old('title.en', $blog->getTranslation('title', 'en')) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter blog title in English"
                                   required>
                            @error('title.en')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Excerpt English -->
                        <div>
                            <label for="excerpt_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Excerpt (English)
                            </label>
                            <textarea id="excerpt_en"
                                      name="excerpt[en]"
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Brief description of the blog post">{{ old('excerpt.en', $blog->getTranslation('excerpt', 'en')) }}</textarea>
                            @error('excerpt.en')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content English -->
                        <div>
                            <label for="content_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Content (English) *
                            </label>
                            <textarea id="content_en"
                                      name="content[en]"
                                      rows="12"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Write your blog content in English"
                                      required>{{ old('content.en', $blog->getTranslation('content', 'en')) }}</textarea>
                            @error('content.en')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Bengali Fields -->
                <div id="lang-bn" class="language-content hidden">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">Bengali Content</h3>
                    
                    <div class="space-y-4">
                        <!-- Title Bengali -->
                        <div>
                            <label for="title_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Title (Bengali)
                            </label>
                            <input type="text" 
                                   id="title_bn"
                                   name="title[bn]"
                                   value="{{ old('title.bn', $blog->getTranslation('title', 'bn')) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="ব্লগের শিরোনাম বাংলায় লিখুন">
                            @error('title.bn')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Excerpt Bengali -->
                        <div>
                            <label for="excerpt_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Excerpt (Bengali)
                            </label>
                            <textarea id="excerpt_bn"
                                      name="excerpt[bn]"
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="ব্লগ পোস্টের সংক্ষিপ্ত বিবরণ">{{ old('excerpt.bn', $blog->getTranslation('excerpt', 'bn')) }}</textarea>
                            @error('excerpt.bn')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content Bengali -->
                        <div>
                            <label for="content_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Content (Bengali)
                            </label>
                            <textarea id="content_bn"
                                      name="content[bn]"
                                      rows="12"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="আপনার ব্লগের বিষয়বস্তু বাংলায় লিখুন">{{ old('content.bn', $blog->getTranslation('content', 'bn')) }}</textarea>
                            @error('content.bn')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin-dashboard.blog.index') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Blog Post
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde@2.18.0/dist/easymde.min.css">
    <style>
        .language-tab {
            @apply border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300;
        }
        .language-tab.active {
            @apply border-blue-500 text-blue-600;
        }
        .dark .language-tab {
            @apply text-gray-400 hover:text-gray-200 hover:border-gray-500;
        }
        .dark .language-tab.active {
            @apply border-blue-400 text-blue-400;
        }
        .EasyMDEContainer .editor-toolbar {
            @apply border-gray-300 dark:border-gray-600;
        }
        .dark .EasyMDEContainer .editor-toolbar {
            @apply bg-gray-700 border-gray-600;
        }
        .dark .EasyMDEContainer .editor-toolbar > * {
            @apply text-gray-300;
        }
        .dark .EasyMDEContainer .CodeMirror {
            @apply bg-gray-700 text-gray-100;
        }
        .dark .EasyMDEContainer .CodeMirror-cursor {
            @apply border-gray-100;
        }
        
        /* Select2 Dark Mode Styles */
        .dark .select2-container--default .select2-selection--multiple {
            background-color: rgb(55 65 81) !important;
            border-color: rgb(75 85 99) !important;
            color: rgb(243 244 246) !important;
        }
        .dark .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: rgb(59 130 246) !important;
            border-color: rgb(37 99 235) !important;
            color: white !important;
        }
        .dark .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        .dark .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: white !important;
        }
        .dark .select2-dropdown {
            background-color: rgb(55 65 81) !important;
            border-color: rgb(75 85 99) !important;
        }
        .dark .select2-container--default .select2-results__option {
            color: rgb(243 244 246) !important;
        }
        .dark .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: rgb(59 130 246) !important;
        }
        .dark .select2-container--default .select2-search--dropdown .select2-search__field {
            background-color: rgb(75 85 99) !important;
            border-color: rgb(107 114 128) !important;
            color: rgb(243 244 246) !important;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/easymde@2.18.0/dist/easymde.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize EasyMDE for English content
            const easyMDE_en = new EasyMDE({
                element: document.getElementById('content_en'),
                spellChecker: false,
                autofocus: false,
                placeholder: 'Write your blog content in English...',
                renderingConfig: {
                    singleLineBreaks: false,
                    codeSyntaxHighlighting: true,
                },
            });

            // Initialize EasyMDE for Bengali content
            const easyMDE_bn = new EasyMDE({
                element: document.getElementById('content_bn'),
                spellChecker: false,
                autofocus: false,
                placeholder: 'আপনার ব্লগের বিষয়বস্তু বাংলায় লিখুন...',
                renderingConfig: {
                    singleLineBreaks: false,
                    codeSyntaxHighlighting: true,
                },
            });

            // Initialize Select2 for tags
            $('#tags').select2({
                placeholder: 'Select tags...',
                allowClear: true,
                width: '100%',
                tags: true,
                tokenSeparators: [',', ' '],
                createTag: function (params) {
                    var term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }
                    return {
                        id: term,
                        text: term,
                        newTag: true
                    };
                }
            });

            // Language tab functionality
            const languageTabs = document.querySelectorAll('.language-tab');
            const languageContents = document.querySelectorAll('.language-content');

            languageTabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetLang = this.dataset.lang;
                    
                    // Update tab states
                    languageTabs.forEach(t => {
                        t.classList.remove('active', 'border-blue-500', 'text-blue-600', 'dark:border-blue-400', 'dark:text-blue-400');
                        t.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-200', 'dark:hover:border-gray-500');
                    });
                    
                    this.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-200', 'dark:hover:border-gray-500');
                    this.classList.add('active', 'border-blue-500', 'text-blue-600', 'dark:border-blue-400', 'dark:text-blue-400');
                    
                    // Update content visibility
                    languageContents.forEach(content => {
                        if (content.id === `lang-${targetLang}`) {
                            content.classList.remove('hidden');
                        } else {
                            content.classList.add('hidden');
                        }
                    });
                    
                    // Refresh EasyMDE instances
                    setTimeout(() => {
                        if (targetLang === 'en') {
                            easyMDE_en.codemirror.refresh();
                        } else {
                            easyMDE_bn.codemirror.refresh();
                        }
                    }, 100);
                });
            });

            // Auto-generate slug from english_title (only if slug is empty or was auto-generated)
            const englishTitleInput = document.getElementById('english_title');
            const slugInput = document.getElementById('slug');
            const originalSlug = slugInput.value;
            let manualSlugEdit = false;

            // Check if slug was manually edited
            slugInput.addEventListener('input', function() {
                manualSlugEdit = true;
            });

            // Auto-generate slug when english_title changes
            englishTitleInput.addEventListener('input', function() {
                // Only auto-generate if slug wasn't manually edited and either is empty or matches auto-generated pattern
                if (!manualSlugEdit) {
                    const slug = this.value
                        .toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-')
                        .trim('-');
                    slugInput.value = slug;
                }
            });

            // Handle form submission
            document.querySelector('form').addEventListener('submit', function() {
                // EasyMDE automatically syncs with the textarea, but let's be explicit
                easyMDE_en.codemirror.save();
                easyMDE_bn.codemirror.save();
            });
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>