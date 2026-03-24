const { registerBlockType } = wp.blocks;
const { RichText, useBlockProps, MediaUploadCheck, MediaUpload } = wp.blockEditor;
const { Button } = wp.components;
const { createElement: el } = wp.element;

registerBlockType('vu-ams/header-hero', {
    title: 'Header Hero',
    icon: 'layout',
    category: 'design',
    attributes: {
        title: {
            type: 'string',
            default: ''
        },
        text: {
            type: 'string',
            default: ''
        },
        image: {
            type: 'string',
            default: ''
        }
    },
    edit: function({ attributes, setAttributes }) {
        const blockProps = useBlockProps();
        
        return el('div', { ...blockProps, style: { padding: '20px', backgroundColor: '#f5f5f5', borderRadius: '4px' } },
            el('h3', null, 'Header Hero Block'),
            el(RichText, {
                tagName: 'h1',
                value: attributes.title,
                onChange: (title) => setAttributes({ title }),
                placeholder: 'Enter title...'
            }),
            el(RichText, {
                tagName: 'p',
                value: attributes.text,
                onChange: (text) => setAttributes({ text }),
                placeholder: 'Enter description...'
            }),
            el(MediaUploadCheck, null,
                el(MediaUpload, {
                    onSelect: (media) => setAttributes({ image: media.url }),
                    allowedTypes: ['image'],
                    render: function({ open }) {
                        return el(Button, { onClick: open, isPrimary: true }, 'Select Image');
                    }
                })
            )
        );
    },
    save: function({ attributes }) {
        return null;
    }
});