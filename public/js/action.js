$(document).ready(function () {

    var source = $('#todo-list-item-template').html();
    var todoTemplate = Handlebars.compile(source);

    var todoListUI = '';
    $.each(todos, function (indexInArray, todo) {
        todoListUI = todoListUI + todoTemplate(todo);
    });
    $('#todo-list').find('li.new').before(todoListUI);

    $('#todo-list')
        .on('dblclick', 'li .content', function (e) {
            $(this).prop('contenteditable', true).focus();
        })
        .on('blur', 'li .content', function (e) {
            //create
            if ($(this).closest('li').is('.new')) {
                var todo = $(e.currentTarget).text().trim();
                var order = $('#todo-list').find('li').length;
                if (todo.length > 0) {
                    $.post("todo/create.php", { content: todo, order: order },
                        function (data, textStatus, jqXHR) {
                            todo = {
                                id: data.id,
                                is_complete: false,
                                content: todo,
                            }
                            var li = todoTemplate(todo);
                            $(e.currentTarget).closest('li').before(li);
                        },
                        "json"
                    );
                    $(e.currentTarget).empty();
                }
            }
            //update
            else {
                var id = $(this).closest('li').data('id');
                var content = $(this).text().trim();
                $.post("todo/update.php", { id: id, content: content },
                    function (data, textStatus, jqXHR) {
                        $(this).prop('contenteditable', false);
                    },
                    "json"
                );
            }
        })
        //delete
        .on('click', 'li .delete', function (e) {
            var result = confirm('Do you want to delete?');
            if (result) {
                var id = $(this).closest('li').data('id');
                $.post("todo/delete.php", { id: id },
                    function (data, textStatus, jqXHR) {
                        $(e.currentTarget).closest('li').remove();
                    },
                    "json"
                );
            }
        })
        //complete
        .on('click', '.checkbox', function (e) {
            if ($(this).closest('li').find('.content').text().length > 0) {
                var id = $(this).closest('li').data('id');
                $.post("todo/complete.php", { id: id },
                    function (data, textStatus, jqXHR) {
                        $(e.currentTarget).closest('li').toggleClass('complete');
                    },
                    "json"
                );

            }
        });
    $('#todo-list').find('ul').sortable({
        items: "li:not(.new)",
        stop: function () {
            var orderPair = [];
            $('#todo-list').find('li:not(.new)').each(function (index, li) {
                var order = index + 1;
                var id = $(li).data('id');
                orderPair.push({ id, order });
            });
            $.post("todo/sort.php", { orderPair: orderPair });
        }
    });
});