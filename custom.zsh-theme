function get_pwd() {
	print -D $PWD
}

function precmd() {
	git="$(git_prompt_info)"
	git_prompt=""
	if [[ ${#git} -gt 0 ]]; then
		git_prompt="%{$reset_color%} on "

		if [[ "$(parse_git_dirty)" == "*" ]]; then
			git_prompt="${git_prompt}$fg[red]+"
		else
			git_prompt="${git_prompt}$fg[green]"
		fi
		git_prompt="${git_prompt}[branch:${git}]"
	fi

	print -rP '$fg[cyan]%m: $fg[yellow]$(get_pwd)${git_prompt}'
}

function git_prompt_info {
  ref=$(git symbolic-ref HEAD 2> /dev/null | cut -b 12-) || return 1
  echo "$ref"
}

function parse_git_dirty {
  [[ "$(git status 2> /dev/null | grep 'working directory clean' | wc -l)" == "0" ]] && echo "*"
}

PROMPT='%{$reset_color%}%n → '

ZSH_THEME_GIT_PROMPT_PREFIX="[git:"
ZSH_THEME_GIT_PROMPT_SUFFIX="]$reset_color"
ZSH_THEME_GIT_PROMPT_DIRTY="$fg[red]+"
ZSH_THEME_GIT_PROMPT_CLEAN="$fg[green]"
