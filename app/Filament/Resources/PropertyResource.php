<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource\RelationManagers;
use App\Models\Property;
use App\Models\Location;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\ToggleFilter;
use Filament\Support\RawJs;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('location_id')
                    ->label('Location')
                    ->options(Location::all()->pluck('name', 'id'))
                    ->required()
                    ->searchable(),
                Textarea::make('description')
                    ->required()
                    ->maxLength(65535),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Ksh')
                    ->mask(RawJs::make(<<<'JS'
                        $money($input, ',', '.', 0)
                    JS))
                    ->formatStateUsing(fn ($state) => number_format($state, 0, '.', ',')),
                Select::make('type')
                    ->options([
                        'Apartment' => 'Apartment',
                        'House' => 'House',
                        'Commercial' => 'Commercial',
                        'Land' => 'Land',
                    ])
                    ->required(),
                Select::make('status')
                    ->options([
                        'Available' => 'Available',
                        'Pending' => 'Pending',
                        'Sold' => 'Sold',
                        'Rented' => 'Rented',
                    ])
                    ->required(),
                TextInput::make('bedrooms')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                TextInput::make('bathrooms')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                TextInput::make('square_feet')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                FileUpload::make('images')
                    ->multiple()
                    ->maxFiles(5),
                Select::make('listed_by')
                    ->label('Listed By')
                    ->options(User::all()->pluck('name', 'id'))
                    ->required()
                    ->searchable(),
                Toggle::make('is_verified')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('location.name')->searchable(),
                Tables\Columns\TextColumn::make('price')->money('KSH'),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('listedBy.name')->searchable(),
                Tables\Columns\IconColumn::make('is_verified')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('location_id')
                    ->options(Location::all()->pluck('name', 'id')),
                SelectFilter::make('type')
                    ->options([
                        'Apartment' => 'Apartment',
                        'House' => 'House',
                        'Commercial' => 'Commercial',
                        'Land' => 'Land',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'Available' => 'Available',
                        'Pending' => 'Pending',
                        'Sold' => 'Sold',
                        'Rented' => 'Rented',
                    ]),
                SelectFilter::make('listed_by')
                    ->options(User::all()->pluck('name', 'id')),
                // ToggleFilter::make('is_verified'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
