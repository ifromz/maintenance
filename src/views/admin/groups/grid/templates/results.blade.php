<script type="text/template" data-grid="groups" data-template="results">

    <% _.each(results, function(r){ %>

    <tr>
        <td><a href="<%= r.view_url %>"> <%= r.name %> </a></td>
    </tr>

    <% }); %>

</script>
