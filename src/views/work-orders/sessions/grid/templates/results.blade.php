<script type="text/template" data-grid="work-order-sessions" data-template="results">

    <% _.each(results, function(r){ %>

    <tr>
        <td><%= r.user %></td>
        <td><%= r.in %></td>
        <td><%= r.out %></td>
    </tr>

    <% }); %>

</script>
