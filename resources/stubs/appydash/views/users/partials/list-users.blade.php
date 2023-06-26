
<x-table-simple

  :columns='[
    [
      "name" => "Name",
      "field" => "name",
      "columnClasses" => "", // classes to style table th      
      "rowClasses" => "" // classes to style table td
    ],
    [
      "name" => "Email",
      "field" => "email",
      "columnClasses" => "",      
      "rowClasses" => ""
    ]
  ]'

  :rows="$users"
>

  <x-slot name="tableActions">
    <div class="flex flex-wrap space-x-4">
      <a :href="`users/${row.id}/edit`" class="text-blue-500 underline">Edit</a>
      <a :href="`users/${row.id}`" class="text-green-500 underline">View</a>
      <a :href="`users/${row.id}/delete`" class="text-red-500 underline">Delete</a>
    </div>
  </x-slot>


</x-table-simple>

{{$pagination->links()}}