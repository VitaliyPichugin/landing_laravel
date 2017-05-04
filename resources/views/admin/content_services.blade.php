<div style="margin:0px 50px 0px 50px;">

    @if($data)

        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>№</th>
                <th>Имя</th>
                <th>Текст</th>
                <th>Иконка</th>
                <th>Дата создания</th>

                <th>Удалить</th>
            </tr>
            </thead>
            <tbody>

            @foreach($data as $p => $item)

                <tr>

                    <td>{{ $item->id }}</td>
                    <td>{!! Html::link(route('ServiceEdit',['services'=>$item->id]),$item->name,['alt'=>$item->name]) !!}</td>
                    <td>{{ $item->text }}</td>
                    <td>{{ $item->icon }}</td>
                    <td>{{ $item->created_at }}</td>

                    <td>
                        {!! Form::open(['url'=>route('ServiceEdit',['services'=>$item->id]), 'class'=>'form-horizontal','method' => 'POST']) !!}

                        {{method_field('DELETE')}}
                        {!! Form::button('Удалить',['class'=>'btn btn-danger','type'=>'submit']) !!}

                        {!! Form::close() !!}
                    </td>
                </tr>

            @endforeach


            </tbody>
        </table>
    @endif

    {!! Html::link(route('ServiceAdd'),'Добавить сервис') !!}

</div>