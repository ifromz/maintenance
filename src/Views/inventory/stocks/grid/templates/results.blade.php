<script type="text/template" data-grid="inventory-stocks" data-template="results">

    <% _.each(results, function(r){ %>

    <tr>
        <td><%= r.quantity %></td>
        <td><%= r.location %></td>
        <td><%= r.last_movement %></td>
        <td><%= r.last_movement_by %></td>
    </tr>

    <% }); %>

</script>
