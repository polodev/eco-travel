<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Create Blog Post</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Add a new blog post with multilingual support</p>
                </div>
                <a href="{{ route('admin-dashboard.blog.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('admin-dashboard.blog.store') }}" method="POST" class="space-y-6">
                @csrf
                
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
                               value="{{ old('english_title') }}"
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
                               value="{{ old('slug') }}"
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
                                <option value="{{ $value }}" {{ old('status', 'draft') === $value ? 'selected' : '' }}>
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
                               value="{{ old('published_at') }}"
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
                               value="{{ old('position', 0) }}"
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
                            <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
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
                           value="{{ old('featured_image') }}"
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
                                   value="{{ old('title.en') }}"
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
                                      placeholder="Brief description of the blog post">{{ old('excerpt.en') }}</textarea>
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
                                      rows="20"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Write your blog content here... (Markdown supported)"
                                      required>{{ old('content.en') }}</textarea>
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
                                   value="{{ old('title.bn') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="বাংলায় ব্লগ শিরোনাম লিখুন">
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
                                      placeholder="ব্লগ পোস্টের সংক্ষিপ্ত বিবরণ">{{ old('excerpt.bn') }}</textarea>
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
                                      rows="20"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="আপনার ব্লগ কন্টেন্ট এখানে লিখুন... (মার্কডাউন সমর্থিত)">{{ old('content.bn') }}</textarea>
                            @error('content.bn')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Other Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Status *
                        </label>
                        <select id="status"
                                name="status"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @foreach ($statuses as $key => $value)
                                <option value="{{ $key }}" {{ old('status', 'draft') == $key ? 'selected' : '' }}>
                                    {{ $value }}
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
                               value="{{ old('published_at') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('published_at')
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
                               value="{{ old('featured_image') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="https://example.com/image.jpg">
                        @error('featured_image')
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
                               value="{{ old('position', 0) }}"
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
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tags')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Hold Ctrl/Cmd to select multiple tags
                    </p>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin-dashboard.blog.index') }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Create Blog Post
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
            @apply text-gray-400 hover:text-gray-200 hover:border-gray-600;
        }
        .dark .language-tab.active {
            @apply border-blue-400 text-blue-400;
        }
        
        .EasyMDEContainer .editor-toolbar {
            border-color: #d1d5db;
        }
        .dark .EasyMDEContainer .editor-toolbar {
            border-color: #4b5563;
            background-color: #374151;
        }
        .dark .EasyMDEContainer .editor-toolbar button {
            color: #d1d5db;
        }
        .dark .EasyMDEContainer .editor-toolbar button:hover {
            background-color: #4b5563;
        }
        .dark .EasyMDEContainer .CodeMirror {
            background-color: #1f2937;
            color: #f9fafb;
            border-color: #4b5563;
        }
        .dark .EasyMDEContainer .CodeMirror-cursor {
            border-left-color: #f9fafb;
        }
        .dark .EasyMDEContainer .editor-preview {
            background-color: #1f2937;
            color: #f9fafb;
        }
        .dark .EasyMDEContainer .editor-preview-side {
            border-color: #4b5563;
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
                autosave: {
                    enabled: true,
                    uniqueId: "blog_create_en",
                    delay: 1000,
                },
                placeholder: "Write your blog content here...",
                status: ['autosave', 'lines', 'words', 'cursor'],
                toolbar: [
                    "bold", "italic", "heading", "|",
                    "quote", "unordered-list", "ordered-list", "|",
                    "link", "image", "table", "|",
                    "code", "horizontal-rule", "|",
                    "preview", "side-by-side", "fullscreen", "|",
                    "guide"
                ],
                shortcuts: {
                    drawTable: "Cmd-Alt-T",
                    togglePreview: "Cmd-P",
                    toggleSideBySide: "F9",
                    toggleFullScreen: "F11"
                },
                previewClass: ["editor-preview", "prose", "prose-sm", "max-w-none"],
                renderingConfig: {
                    singleLineBreaks: false,
                    codeSyntaxHighlighting: true,
                },
            });

            // Initialize EasyMDE for Bengali content
            const easyMDE_bn = new EasyMDE({
                element: document.getElementById('content_bn'),
                spellChecker: false,
                autosave: {
                    enabled: true,
                    uniqueId: "blog_create_bn",
                    delay: 1000,
                },
                placeholder: "আপনার ব্লগ কন্টেন্ট এখানে লিখুন...",
                status: ['autosave', 'lines', 'words', 'cursor'],
                toolbar: [
                    "bold", "italic", "heading", "|",
                    "quote", "unordered-list", "ordered-list", "|",
                    "link", "image", "table", "|",
                    "code", "horizontal-rule", "|",
                    "preview", "side-by-side", "fullscreen", "|",
                    "guide"
                ],
                shortcuts: {
                    drawTable: "Cmd-Alt-T",
                    togglePreview: "Cmd-P",
                    toggleSideBySide: "F9",
                    toggleFullScreen: "F11"
                },
                previewClass: ["editor-preview", "prose", "prose-sm", "max-w-none"],
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

            // Auto-generate slug from english_title
            const englishTitleInput = document.getElementById('english_title');
            const slugInput = document.getElementById('slug');
            let manualSlugEdit = false;

            // Check if slug was manually edited
            slugInput.addEventListener('input', function() {
                manualSlugEdit = true;
            });

            // Auto-generate slug when english_title changes
            englishTitleInput.addEventListener('input', function() {
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
