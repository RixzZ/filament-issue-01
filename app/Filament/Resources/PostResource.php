<?php

namespace App\Filament\Resources;

use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Forms;
use App\Models\Post;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Filament\Resources\PostResource\Pages;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->autofocus()
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->autofocus()
                            ->required(),
                    ])
                    ->required()
                    ->preload(),
                Forms\Components\Textarea::make('content')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup(
                Tables\Grouping\Group::make('category.name')
                    ->titlePrefixedWithLabel(false),
            )
            ->groupingSettingsHidden(true)
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
