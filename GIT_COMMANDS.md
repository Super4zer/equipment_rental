# Git Commands Reference

## ✅ Repository Successfully Pushed!

Your project has been successfully pushed to:
**https://github.com/Super4zer/equipment_rental.git**

---

## 📝 Common Git Commands

### Initial Setup (Already Done)

```bash
git init
git add .
git commit -m "Initial commit"
git branch -M main
git remote add origin https://github.com/Super4zer/equipment_rental.git
git push -u origin main
```

### Daily Workflow

#### 1. Check Status

```bash
git status
```

#### 2. Add Changes

```bash
# Add all changes
git add .

# Add specific file
git add filename.php

# Add specific folder
git add app/Http/Controllers/
```

#### 3. Commit Changes

```bash
# With message
git commit -m "Your commit message"

# With detailed message
git commit -m "Title" -m "Detailed description"
```

#### 4. Push to GitHub

```bash
# First time
git push -u origin main

# Subsequent pushes
git push
```

#### 5. Pull Latest Changes

```bash
git pull origin main
```

### Commit Message Conventions

Use semantic commit messages:

```bash
# Features
git commit -m "feat: Add notification system"

# Bug fixes
git commit -m "fix: Resolve seeder duplicate entry error"

# Documentation
git commit -m "docs: Update README"

# Refactoring
git commit -m "refactor: Improve controller structure"

# Styling
git commit -m "style: Update UI colors"

# Tests
git commit -m "test: Add unit tests for notifications"

# Chores
git commit -m "chore: Update dependencies"
```

### Branch Management

#### Create New Branch

```bash
# Create and switch to new branch
git checkout -b feature/new-feature

# Or using newer syntax
git switch -c feature/new-feature
```

#### Switch Branch

```bash
git checkout main
# or
git switch main
```

#### List Branches

```bash
git branch
```

#### Delete Branch

```bash
# Delete local branch
git branch -d feature/old-feature

# Force delete
git branch -D feature/old-feature
```

### Viewing History

#### View Commit Log

```bash
# Simple log
git log

# One line per commit
git log --oneline

# With graph
git log --oneline --graph --all

# Last 5 commits
git log -5
```

#### View Changes

```bash
# Unstaged changes
git diff

# Staged changes
git diff --staged

# Changes in specific file
git diff filename.php
```

### Undoing Changes

#### Unstage File

```bash
git reset HEAD filename.php
```

#### Discard Changes

```bash
# Discard changes in working directory
git checkout -- filename.php

# Discard all changes
git checkout -- .
```

#### Undo Last Commit (Keep Changes)

```bash
git reset --soft HEAD~1
```

#### Undo Last Commit (Discard Changes)

```bash
git reset --hard HEAD~1
```

### Remote Repository

#### View Remote

```bash
git remote -v
```

#### Add Remote

```bash
git remote add origin https://github.com/username/repo.git
```

#### Change Remote URL

```bash
git remote set-url origin https://github.com/username/new-repo.git
```

#### Remove Remote

```bash
git remote remove origin
```

### Stashing Changes

#### Save Changes Temporarily

```bash
git stash
```

#### List Stashes

```bash
git stash list
```

#### Apply Stash

```bash
# Apply latest stash
git stash apply

# Apply specific stash
git stash apply stash@{0}
```

#### Drop Stash

```bash
git stash drop
```

### Tagging

#### Create Tag

```bash
# Lightweight tag
git tag v1.0.0

# Annotated tag
git tag -a v1.0.0 -m "Version 1.0.0"
```

#### Push Tags

```bash
# Push specific tag
git push origin v1.0.0

# Push all tags
git push --tags
```

#### List Tags

```bash
git tag
```

### Collaboration

#### Clone Repository

```bash
git clone https://github.com/Super4zer/equipment_rental.git
```

#### Fetch Changes

```bash
git fetch origin
```

#### Pull with Rebase

```bash
git pull --rebase origin main
```

#### Create Pull Request

1. Fork repository on GitHub
2. Clone your fork
3. Create feature branch
4. Make changes and commit
5. Push to your fork
6. Create PR on GitHub

### .gitignore

Common entries for Laravel:

```gitignore
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.phpunit.result.cache
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log
```

### Useful Aliases

Add to `~/.gitconfig`:

```bash
[alias]
    st = status
    co = checkout
    br = branch
    ci = commit
    unstage = reset HEAD --
    last = log -1 HEAD
    lg = log --oneline --graph --all
```

Usage:

```bash
git st        # instead of git status
git co main   # instead of git checkout main
git lg        # pretty log
```

## 🚀 Quick Reference for This Project

### After Making Changes

```bash
# 1. Check what changed
git status

# 2. Add changes
git add .

# 3. Commit with message
git commit -m "feat: Add new feature"

# 4. Push to GitHub
git push
```

### Update from GitHub

```bash
# Pull latest changes
git pull origin main
```

### Create Feature Branch

```bash
# Create and switch to feature branch
git checkout -b feature/awesome-feature

# Make changes, commit
git add .
git commit -m "feat: Add awesome feature"

# Push feature branch
git push -u origin feature/awesome-feature

# Merge to main (on GitHub via PR or locally)
git checkout main
git merge feature/awesome-feature
git push
```

## 📊 Current Repository Status

-   **Repository**: https://github.com/Super4zer/equipment_rental.git
-   **Branch**: main
-   **Files**: 109 files
-   **Commits**: 3 commits
-   **Status**: ✅ Up to date with remote

## 🔗 Useful Links

-   **Repository**: https://github.com/Super4zer/equipment_rental
-   **Issues**: https://github.com/Super4zer/equipment_rental/issues
-   **Pull Requests**: https://github.com/Super4zer/equipment_rental/pulls

## 💡 Tips

1. **Commit Often**: Small, frequent commits are better than large ones
2. **Write Good Messages**: Clear commit messages help track changes
3. **Pull Before Push**: Always pull latest changes before pushing
4. **Use Branches**: Create branches for new features
5. **Review Before Commit**: Check `git status` and `git diff` before committing

---

Happy coding! 🎉
