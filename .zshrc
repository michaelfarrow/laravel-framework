#move to specified start dir

export ZSH=$HOME/.oh-my-zsh
ZSH_THEME="custom"
export PATH=$HOME/bin:/usr/local/bin:$PATH
source $ZSH/oh-my-zsh.sh

START_DIR_FILE="$HOME/.start_dir"

if [ -f $START_DIR_FILE ]
then
    cd `cat "$START_DIR_FILE"`
fi

# If not running interactively, don't do anything
# [ -z "$PS1" ] && return

function command_exists () {
    type "$1" &> /dev/null ;
}

# don't put duplicate lines or lines starting with space in the history.
# See bash(1) for more options
HISTCONTROL=ignoreboth

# append to the history file, don't overwrite it
# shopt -s histappend

# for setting history length see HISTSIZE and HISTFILESIZE in bash(1)
HISTSIZE=1000
HISTFILESIZE=2000

# check the window size after each command and, if necessary,
# update the values of LINES and COLUMNS.
# shopt -s checkwinsize

# If set, the pattern "**" used in a pathname expansion context will
# match all files and zero or more directories and subdirectories.
#shopt -s globstar

# function git_prompt_info {
#   ref=$(git symbolic-ref HEAD 2> /dev/null | cut -b 12-) || return 1
#   echo "$ref"
# }

plugins=(git)

# function prompt_char {
#   # if command_exists git; then
#   #   git branch >/dev/null 2>/dev/null && echo '±' && return
#   # fi
#   echo '→'
# }

# USER_COLOURS_FILE="$HOME/.user_colours"

# PS1_BASE='\[\033[m\]'

# function parse_git_dirty {
#   [[ "$(git status 2> /dev/null | tail -n1 | grep 'working directory clean' | wc -l)" == "0" ]] && echo "*"
# }

# PS1_END='\h: \[\033[0;33m\]\w\[\033[0;0m\]$( git="$(git_prompt_info)"; [[ ${#git} -gt 0 ]] && echo -n " on \[\033[0;32m\]$( [[ "$(parse_git_dirty)" == "*" ]] && echo "\[\033[0;31m\]+" )[branch:${git}]" )\[\033[m\]\n$( [[ $UID -eq 0 ]] && echo "\[\033[0;35m\]" )\u\[\033[m\] $(prompt_char) '

# if [ -f "$USER_COLOURS_FILE" ]
# then
# 	PS1_USER=`cat "$USER_COLOURS_FILE"`
# else
# 	PS1_USER='\[\033[0;36m\]'
# fi

# export PS1="$PS1_BASE$PS1_USER$PS1_END"

export CLICOLOR=1
LS_COLORS='no=00;37:fi=00:di=00;33:ln=04;36:pi=40;33:so=01;35:bd=40;33;01:'
export LS_COLORS
zstyle ':completion:*' list-colors ${(s.:.)LS_COLORS}

export PATH="$HOME/.rbenv/bin:$PATH"
export PATH=/usr/local/lib/node_modules/grunt-cli/bin:$PATH

if command_exists rbenv; then
	eval "$(rbenv init -)"
fi

set completion-ignore-case on

# bind "set completion-ignore-case on"
# bind "set show-all-if-ambiguous on"
# bind "TAB:menu-complete"

if ls --color 1>/dev/null 2>&1; then
    alias ls='ls -l -a --color=auto'
else
    alias ls='ls -l -a -G'
fi

alias restartserver='sudo apachectl restart';
alias flushdns='sudo killall -HUP mDNSResponder && sudo dscacheutil -flushcache'
alias o='open .'
alias c='clear'
alias cd..='cd ..'
alias subl='/Applications/Sublime\ Text.app/Contents/SharedSupport/bin/subl ./'

alias comp='composer'
alias compd='composer dumpautoload'
alias art='php artisan'
alias mig='art migrate'
alias migr='art migrate:refresh'
alias seed='art db:seed'
alias sshscan='nmap -p 22 --open'
alias x='exit'

genpass() {
    local l=$1
    [ "$l" == "" ] && l=16
        env LC_CTYPE=C tr -dc "a-zA-Z0-9" < /dev/urandom | head -c $l

    echo ""
}

export DISABLE_NOTIFIER=true
