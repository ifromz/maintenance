<script type="text/template" data-grid="work-order-sessions" data-template="pagination">

    <% _.each(pagination, function(p) { %>

    <li data-grid="main" data-page="<%= p.page %>"><%= p.page_start %> - <%= p.page_limit %></li>

    <% }); %>

</script>
