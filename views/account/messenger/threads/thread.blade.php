<div class="list-group-item{{ $thread->isUnread() ? '' : ' seen' }}">
	<a href="{{ url('account/messages/' . $thread->id) }}" class="list-box-content">
		<span style="font-size:14px;font-weight: 800;" class="name">
			<?php $userIsOnline = isUserOnline($thread->creator()) ? 'online' : 'offline'; ?>
			 {{ \Illuminate\Support\Str::limit($thread->creator()->name, 20) }} <i class="fa fa-circle {{ $userIsOnline }}"></i>
		</span>
		<div class="message-text">
			{{ \Illuminate\Support\Str::limit($thread->latest_message->body ?? '', 100) }}
		</div>
		<div class="time text-muted">{{ $thread->created_at_formatted }}</div>
	</a>
	
	<div class="list-box-action">
		<a href="{{ url('account/messages/' . $thread->id . '/delete') }}"
		   data-toggle="tooltip"
		   data-placement="top"
		   title="{{ t('Delete') }}"
		>
			<i style="font-size: 11px!important;" class="fas fa-trash"></i>
		</a>
	</div>
</div>