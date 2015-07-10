document.observe("dom:loaded", function() {
    $$('input[id*="_countdown_width"]').first().addClassName('validate-number');
    $$('input[id*="_countdown_height"]').first().addClassName('validate-number');
    $$('input[id*="_border_size"]').first().addClassName('validate-number');
    $$('input[id*="_numbers_item"]').first().addClassName('validate-number');
    $$('input[id*="_countdown_color"]').first().addClassName('color');
    $$('input[id*="_border_color"]').first().addClassName('color');
});