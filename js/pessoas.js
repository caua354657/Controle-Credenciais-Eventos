function myFunction() 
{
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    for(i = 1; i < tr.length; i++) // começa em 1 para ignorar o cabeçalho
    {
        td = tr[i].getElementsByTagName("td");
        let found = false;

        for(j = 0; j < td.length; j++)
        {
            txtValue = td[j].textContent || td[j].innerText;
            if(txtValue.toUpperCase().indexOf(filter) > -1)
            {
                found = true;
                break;
            }
        }

        tr[i].style.display = found ? "" : "none";
    }
}