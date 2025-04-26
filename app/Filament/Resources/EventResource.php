<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\BelongsToManyMultiSelect;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Eventos';
    protected static ?string $modelLabel = 'Evento';
    protected static ?string $slug = 'eventos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Evento')
                    ->schema([
                        Select::make('user_id')
                            ->label('Organizador')
                            ->relationship('user', 'name')
                            ->default(Auth::id())
                            ->disabled()
                            ->columnSpanFull(),
                        
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Select::make('category_id')
                                    ->label('Categoría')
                                    ->options(Category::all()->pluck('name', 'id'))
                                    ->required()
                                    ->searchable(),
                                
                                    BelongsToManyMultiSelect::make('tags')
                                    ->relationship('tags', 'name')
                                    ->required()
                                    ->preload(),
                            ]),
                        
                        Forms\Components\TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        
                        RichEditor::make('description')
                            ->label('Descripción')
                            ->required()
                            ->fileAttachmentsDirectory('events/attachments')
                            ->columnSpanFull(),
                        
                        Forms\Components\Grid::make(2)
                            ->schema([
                                DateTimePicker::make('start_date')
                                    ->label('Fecha de inicio')
                                    ->required()
                                    ->native(false)
                                    ->minutesStep(30),
                                
                                DateTimePicker::make('end_date')
                                    ->label('Fecha de finalización')
                                    ->required()
                                    ->native(false)
                                    ->minutesStep(30)
                                    ->rules(['after:start_date']),
                            ]),
                        
                        Forms\Components\TextInput::make('location')
                            ->label('Ubicación')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                
                TextColumn::make('category.name')
                    ->label('Categoría')
                    ->sortable(),
                
                TextColumn::make('start_date')
                    ->label('Inicio')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                
                TextColumn::make('end_date')
                    ->label('Fin')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                
                TextColumn::make('location')
                    ->label('Ubicación')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                ->relationship('category', 'name')
                ->label('Filtrar por categoría'),
            
            Tables\Filters\Filter::make('fechas')
                ->form([
                    Forms\Components\DatePicker::make('start_date')
                        ->label('Desde'),
                    Forms\Components\DatePicker::make('end_date')
                        ->label('Hasta'),
                ])
                ->query(function (\Illuminate\Database\Eloquent\Builder $query, array $data): \Illuminate\Database\Eloquent\Builder {
                    return $query
                        ->when(
                            $data['start_date'] ?? null,
                            fn ($query, $date) => $query->whereDate('start_date', '>=', $date)
                        )
                        ->when(
                            $data['end_date'] ?? null,
                            fn ($query, $date) => $query->whereDate('end_date', '<=', $date)
                        );
                })
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil'),
                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('start_date', 'desc')
            ->deferLoading()
            ->emptyStateHeading('No hay eventos registrados');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}