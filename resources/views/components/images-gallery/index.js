const { registerBlockType } = wp.blocks;
const { RichText } = wp.blockEditor;

registerBlockType('vu-ams/images-gallery', {
    edit({ attributes, setAttributes }) {
        return (
            wp.element.createElement(RichText, {
                tagName: 'h2',
                value: attributes.title,
                placeholder: 'Title...',
                onChange: (title) => setAttributes({ title })
            })
        );
    },

    save() {
        return null; // dynamic block
    }
});