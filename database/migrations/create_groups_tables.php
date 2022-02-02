<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('short_description')->nullable();
            $table->string('image')->nullable();
            $table->string('url')->nullable();
            $table->foreignId('user_id');
            $table->boolean('private')->unsigned()->default(false);
            $table->unsignedBigInteger('conversation_id')->nullable();
            $table->text('extra_info')->nullable();
            $table->text('settings')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('group_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('group_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('cascade');
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->string('type');
            $table->foreignId('user_id');
            $table->text('extra_info')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('body');
            $table->foreignId('user_id');
            $table->foreignId('post_id');
            $table->string('type')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('post_id')
                ->references('id')
                ->on('posts');
        });

        Schema::create('group_post', function (Blueprint $table) {
            $table->foreignId('group_id');
            $table->foreignId('post_id');
            $table->timestamps();

            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('cascade');

            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');
        });

        Schema::create('likes', function (Blueprint $table) {
            $table->foreignId('user_id')->index();
            $table->unsignedBigInteger('likeable_id');
            $table->string('likeable_type');
            $table->primary(['user_id', 'likeable_id', 'likeable_type']);
            $table->timestamps();
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->foreignId('user_id')->index();
            $table->unsignedBigInteger('reportable_id');
            $table->string('reportable_type');
            $table->primary(['user_id', 'reportable_id', 'reportable_type']);
            $table->timestamps();
        });

        Schema::create('group_request', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->foreignId('group_id')->index();
            $table->timestamps();

            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('groups');
        Schema::drop('group_user');
        Schema::drop('posts');
        Schema::drop('comments');
        Schema::drop('group_post');
        Schema::drop('likes');
        Schema::drop('reports');
        Schema::drop('group_request');
    }
}
