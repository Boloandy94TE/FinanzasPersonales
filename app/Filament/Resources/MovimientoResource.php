<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovimientoResource\Pages;
use App\Filament\Resources\MovimientoResource\RelationManagers;
use App\Models\Categoria;
use App\Models\Movimiento;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MovimientoResource extends Resource
{
    protected static ?string $model = Movimiento::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form

            ->schema([

            Card::make('Llene los campos del formulario')
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->label('Usuarios')
                        ->required()
                        ->options(User::all()->pluck('name', 'id')),

                    Forms\Components\Select::make('categoria_id')
                        ->required()
                        ->label('Categoría')
                        ->options(Categoria::all()->pluck('nombre', 'id')),

                    Forms\Components\Select::make('tipo')
                        ->required()
                        ->options([
                            'ingreso' => 'Ingreso',
                            'gasto' => 'Gasto',
                        ]),

                    Forms\Components\TextInput::make('monto')
                        ->required()
                        ->label('Valor ($)')
                        ->numeric(),

                    Forms\Components\RichEditor::make('descripcion')
                        ->required()
                        ->label('Descripción')
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('foto')
                        ->label('Imagen')
                        ->image()
                        ->disk('public')
                        ->directory('movimientos'),

                    Forms\Components\DatePicker::make('fecha')
                        ->required(),
                ])
                ->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Nro')
                    ->rowIndex()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('categoria.nombre')
                    ->label('Categoría')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->label('Tipo de movimiento')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('monto')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('descripcion')
                    ->limit(50)
                    ->html()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\ImageColumn::make('foto')
                    ->searchable()
                    ->width(100)
                    ->height(100),
                Tables\Columns\TextColumn::make('fecha')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('tipo')
                    ->options([
                        'ingreso' => 'Ingreso',
                        'gasto' => 'Gasto',
                    ])
                    ->placeholder('Filtrar por tipo')
                    ->label('Tipo'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->button()
                ->color('primary'),
                Tables\Actions\DeleteAction::make()
                ->button()
                ->color('danger')
                ->successNotification(
                    Notification::make()
                        ->title('Movimiento Eliminado')
                        ->body('El movimiento ha sido eliminado')
                        ->success()
                ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMovimientos::route('/'),
            'create' => Pages\CreateMovimiento::route('/create'),
            'edit' => Pages\EditMovimiento::route('/{record}/edit'),
        ];
    }
}
