wp.domReady(function() {
    // Lock blocks immediately after editor loads
    const { getBlocks } = wp.data.select('core/block-editor');
    const { updateBlockAttributes } = wp.data.dispatch('core/block-editor');
    
    // Apply lock settings to all VU-AMS blocks
    const blocks = getBlocks();
    blocks.forEach(block => {
        if (block.name === 'vu-ams/header-hero') {
            updateBlockAttributes(block.clientId, {
                lock: {
                    remove: true,  // Prevent deleting
                    move: false    // Allow moving
                }
            });
        }
    });

    // Subscribe to block changes and reapply locks when new blocks are added
    wp.data.subscribe(function() {
        const currentBlocks = wp.data.select('core/block-editor').getBlocks();
        currentBlocks.forEach(block => {
            if (block.name === 'vu-ams/header-hero' && !block.attributes.lock) {
                updateBlockAttributes(block.clientId, {
                    lock: {
                        remove: true,
                        move: false
                    }
                });
            }
        });
    });
});
