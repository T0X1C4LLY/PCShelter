@props(['id', 'loading', 'name'])

<script type="text/javascript">
    let pageNumber = 1;
    loadMoreData(pageNumber);
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height()) {
            loadMoreData(++pageNumber);
        }
    });
    function loadMoreData(pageNumber) {
        $.ajax({
            url: '?page=' + pageNumber,
            type: 'get',
            datatype: 'html',
            beforeSend: function() {
                $('.{{ $loading }}').show();
            }
        })
            .done(function(data) {
                if(data.length === 0) {
                    $('.{{ $loading }}').html('No more {{ $name }} to show.');
                } else {
                    $('.{{ $loading}}').hide();
                    $('#{{ $id }}').append(data);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('Something went wrong.');
            });
    }
</script>
