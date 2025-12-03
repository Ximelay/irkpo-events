<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Категории инвентаря
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Список категорий</h3>
                        <a href="{{ route('inventory-categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Добавить категорию
                        </a>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                            <span class="block sm:inline">{{ $message }}</span>
                        </div>
                    @endif

                    <table class="min-w-full bg-white mt-4">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">ID</th>
                                <th class="py-2 px-4 border-b">Название</th>
                                <th class="py-2 px-4 border-b">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventoryCategories as $category)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $category->inventoryCategoryID }}</td>
                                    <td class="py-2 px-4 border-b">{{ $category->nameInventoryCategory }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="{{ route('inventory-categories.show', $category) }}" class="text-blue-600 hover:text-blue-800 font-medium">Просмотр</a>
                                        <a href="{{ route('inventory-categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-800 font-medium ml-2">Редактировать</a>
                                        <form action="{{ route('inventory-categories.destroy', $category) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium ml-2">Удалить</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

