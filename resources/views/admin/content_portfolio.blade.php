<div style="margin:0px 50px 0px 50px;">

    @if($portfolio)

        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>№</th>
                <th>Имя</th>
                <th>Картинка</th>
                <th>Фильтр</th>
                <th>Дата создания</th>

                <th>Удалить</th>
            </tr>
            </thead>
            <tbody>

            @foreach($portfolio as $p => $item)

                <tr>

                    <td>{{ $item->id }}</td>
                    <td>{!! Html::link(route('PortfolioEdit',['portfolio'=>$item->id]),$item->name,['alt'=>$item->name]) !!}</td>
                    <td>{{ $item->img }}</td>
                    <td>{{ $item->filter }}</td>
                    <td>{{ $item->created_at }}</td>

                    <td>
                        {!! Form::open(['url'=>route('PortfolioEdit',['portfolio'=>$item->id]), 'class'=>'form-horizontal','method' => 'POST']) !!}

                        {{method_field('DELETE')}}
                        {!! Form::button('Удалить',['class'=>'btn btn-danger','type'=>'submit']) !!}

                        {!! Form::close() !!}
                    </td>
                </tr>

            @endforeach


            </tbody>
        </table>
    @endif

    {!! Html::link(route('PortfolioAdd'),'Добавить портфолио') !!}

</div>