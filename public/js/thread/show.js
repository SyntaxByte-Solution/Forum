
$('.share-post-form textarea').each(function() {
    var simplemde = new SimpleMDE({
        element: this,
        hideIcons: ["guide", "heading", "image"],
        spellChecker: false,
        mode: 'markdown',
        showMarkdownLineBreaks: true,
    });
});