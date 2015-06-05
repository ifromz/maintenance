<script type="text/template" data-grid="parts" data-template="results">

    <% _.each(results, function(r){ %>

    <tr>
        <td><%= r.item_id %></td>
        <td><%= r.item_sku %></td>
        <td><a href="<%= r.item_view_url %>"><%= r.item_name %></a></td>
        <td><%= r.location %></td>
        <td><%= r.quantity_taken %></td>
        <td><%= r.date_taken %></td>
        <td><a class="btn btn-sm btn-primary" href="<%= r.put_back_url %>">Put Back</a></td>
    </tr>

    <% }); %>

</script>
