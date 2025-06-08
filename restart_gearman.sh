#!/bin/bash
if ! pgrep gearmand > /dev/null; then
    echo "Gearman is not running. Restarting..."
    gearmand -d
    if [ $? -eq 0 ]; then
        echo "Gearman restarted successfully."
    else
        echo "Failed to restart Gearman."
    fi
else
    echo "Gearman is running."
fi